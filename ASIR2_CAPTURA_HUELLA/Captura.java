import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.EnumMap;
import java.util.concurrent.LinkedBlockingQueue;
import java.util.Scanner;
import java.util.Arrays;
import java.text.SimpleDateFormat;
import java.util.Date;


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
		DPFPFeatureExtraction extractor = DPFPGlobal.getFeatureExtractionFactory().createFeatureExtraction();
		DPFPTemplate plantillaBBDD = DPFPGlobal.getTemplateFactory().createTemplate();
		DPFPVerification verificador = DPFPGlobal.getVerificationFactory().createVerification();

		try{
		while(true){
        	DPFPSample huella = recibirCaptura();

			ResultSet resultados = capturador.get();

			while(resultados.next()){
				byte[] huellaBBDD = resultados.getBytes("huella");
				String nombreUsuario = resultados.getString("nombre_dedo");
				plantillaBBDD.deserialize(huellaBBDD);

				DPFPFeatureSet features = extractor.createFeatureSet(huella, DPFPDataPurpose.DATA_PURPOSE_VERIFICATION);  

				verificador.setFARRequested(DPFPVerification.MEDIUM_SECURITY_FAR);
				DPFPVerificationResult resultado = verificador.verify(features, plantillaBBDD);
				System.out.println("\n" + resultado.isVerified());

				if(resultado.isVerified() == true){
					SimpleDateFormat formatter= new SimpleDateFormat("yyyy-MM-dd 'at' HH:mm:ss z");
					Date date = new Date(System.currentTimeMillis());

					System.out.println(nombreUsuario + " " + formatter.format(date) );
					break;
					//TODO: Parar ejecucion cuando encuentre huella correspondiente.
					//TODO: definir metodo insertarRegistro() para insertar un registro con hora y usuario.
				}
			}
		}

        } catch(Exception e1){
            e1.printStackTrace();
        }
	}

	/**************************************************************************************************************** */
	/**************************************************************************************************************** */


	//Metodos definidos para la clase Captura. Autor: Unai Zelaia-Zugadi.

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

	/**************************************************************************************************************** */
	/**************************************************************************************************************** */
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

	/**************************************************************************************************************** */
	/**************************************************************************************************************** */

	public Connection cn() {
		Connection conn = null;
		try { Class.forName("com.mysql.jdbc.Driver");
		conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/tienda2122", "tienda2122", "123");
		} catch(Exception e) { System.out.println(e); }
		
		return conn;
	}

	/**************************************************************************************************************** */
	/**************************************************************************************************************** */

	public ResultSet get(){
		ResultSet rs = null;
		PreparedStatement st;
		try {
			st = cn().prepareStatement("SELECT huella, nombre_dedo FROM huellas");
			rs = st.executeQuery();
			return rs;
		}catch (Exception e) {
			System.out.println(e.getMessage());
			return rs;
		}
	}

}
