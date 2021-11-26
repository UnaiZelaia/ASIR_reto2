import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.EnumMap;
import java.util.concurrent.LinkedBlockingQueue;
import java.util.Scanner;
import java.util.Arrays;

import com.digitalpersona.onetouch.*;
import com.digitalpersona.onetouch.capture.DPFPCapture;
import com.digitalpersona.onetouch.capture.DPFPCapturePriority;
import com.digitalpersona.onetouch.capture.event.DPFPDataEvent;
import com.digitalpersona.onetouch.capture.event.DPFPDataAdapter;
import com.digitalpersona.onetouch.capture.event.DPFPDataListener;
import com.digitalpersona.onetouch.capture.event.DPFPReaderStatusAdapter;
import com.digitalpersona.onetouch.capture.event.DPFPReaderStatusEvent;
import com.digitalpersona.onetouch.processing.DPFPEnrollment;
import com.digitalpersona.onetouch.processing.DPFPFeatureExtraction;
import com.digitalpersona.onetouch.processing.DPFPImageQualityException;
import com.digitalpersona.onetouch.readers.DPFPReaderDescription;
import com.digitalpersona.onetouch.readers.DPFPReadersCollection;
import com.digitalpersona.onetouch.verification.DPFPVerification;
import com.digitalpersona.onetouch.verification.DPFPVerificationResult;

public class Captura{
    public static void main(String[] args) {
		Captura capturador = new Captura();
        listarLectores();
		try{
        DPFPSample huella = recibirCaptura();
        byte [] huellaSerializada = huella.serialize();
		String huellaPrint = Arrays.toString(huellaSerializada);

		byte [] huellaTemp = capturador.get();
		DPFPTemplate temp = DPFPGlobal.getTemplateFactory().createTemplate();
		temp.deserialize(huellaTemp);


		DPFPFeatureExtraction extractor = DPFPGlobal.getFeatureExtractionFactory().createFeatureExtraction();
		DPFPFeatureSet features = extractor.createFeatureSet(huella, DPFPDataPurpose.DATA_PURPOSE_VERIFICATION);  

		DPFPVerification verificador = DPFPGlobal.getVerificationFactory().createVerification();
		verificador.setFARRequested(DPFPVerification.MEDIUM_SECURITY_FAR);
		DPFPVerificationResult resultado = verificador.verify(features, temp);
		if (resultado.isVerified() == true){
			insert();
		}
        } catch(Exception e1){
            e1.printStackTrace();
        }
	}


    public static void listarLectores() {
        DPFPReadersCollection readers = DPFPGlobal.getReadersFactory().getReaders();
        if (readers == null || readers.size() == 0) {
            System.out.printf("No hay lectores disponibles.\n");
            return;
        }
        System.out.printf("Lector:\n");
        for (DPFPReaderDescription readerDescription : readers)
            System.out.println(readerDescription.getSerialNumber());
    }

    public static DPFPSample recibirCaptura() 
    throws InterruptedException
    {
        final LinkedBlockingQueue<DPFPSample> samples = new LinkedBlockingQueue<DPFPSample>();

        DPFPCapture capturador = DPFPGlobal.getCaptureFactory().createCapture();
	    capturador.setPriority(DPFPCapturePriority.CAPTURE_PRIORITY_LOW);
        capturador.addDataListener(new DPFPDataListener()
	    {
	        public void dataAcquired(DPFPDataEvent event) {
	            if (event != null && event.getSample() != null) {
	                try { 
	                    samples.put(event.getSample());
	                } catch (InterruptedException e1) {
	                    e1.printStackTrace();
	                } 
	            } 
	        } 
	    }); 
        capturador.addReaderStatusListener(new DPFPReaderStatusAdapter()
	    { 
	    	int lastStatus = DPFPReaderStatusEvent.READER_CONNECTED;
			public void readerConnected(DPFPReaderStatusEvent e) {
				if (lastStatus != e.getReaderStatus())
					System.out.println("Reader is connected");
				lastStatus = e.getReaderStatus();
			} 
			public void readerDisconnected(DPFPReaderStatusEvent e) {
				if (lastStatus != e.getReaderStatus())
					System.out.println("Reader is disconnected");
				lastStatus = e.getReaderStatus();
			} 
	    	 
	    }); 
	    try { 
	        capturador.startCapture();
	        System.out.print("Introduce tu huella");
	        return samples.take();
	    } catch (RuntimeException e) {
	        System.out.printf("Fallo al inicializar captura.\n");
	        throw e;
	    } finally { 
	        capturador.stopCapture();
	    } 
	} 


	public Connection cn() {
		Connection conn = null;
		try { Class.forName("com.mysql.jdbc.Driver");
		conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/tienda2122", "tienda2122", "123");
		} catch(Exception e) { System.out.println(e); }
		
		return conn;
	}


	public byte[] get(){ 
		ResultSet rs;
		PreparedStatement st;
		byte[] digital = null;
		try { 
			st = cn().prepareStatement("SELECT huella FROM huellas WHERE nombre_dedo='%'");
			rs = st.executeQuery();
			if(rs.next())
				digital = rs.getBytes("huella");
			else 
				System.out.println("Record not available");
			 
		} catch (Exception e) {
			System.out.println(e.getMessage());
		} 
		 
		return digital;
	}
    }
