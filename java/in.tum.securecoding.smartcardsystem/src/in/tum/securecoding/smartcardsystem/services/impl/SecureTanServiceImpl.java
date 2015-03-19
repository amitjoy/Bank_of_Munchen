package in.tum.securecoding.smartcardsystem.services.impl;

import in.tum.securecoding.smartcardsystem.services.ISecureTANService;

import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.URISyntaxException;
import java.net.URL;
import java.security.InvalidKeyException;
import java.security.KeyFactory;
import java.security.NoSuchAlgorithmException;
import java.security.interfaces.RSAPublicKey;
import java.security.spec.InvalidKeySpecException;
import java.security.spec.X509EncodedKeySpec;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;


public class SecureTanServiceImpl implements ISecureTANService {

	@Override
	public String generate(String accountNo)
			throws NoSuchAlgorithmException, NoSuchPaddingException,
			InvalidKeyException, IllegalBlockSizeException, BadPaddingException, InvalidKeySpecException, IOException, URISyntaxException {
		
		final File file = new File("public.key");
		
		
		DataInputStream dis = new DataInputStream(new FileInputStream(file));
		byte[] keyBytes = new byte[(int) file.length()];
		 
		dis.readFully(keyBytes);
		dis.close();
		X509EncodedKeySpec keySpec = new X509EncodedKeySpec(keyBytes);
		KeyFactory keyFactory = KeyFactory.getInstance("RSA");
		RSAPublicKey publicKey = (RSAPublicKey)keyFactory.generatePublic(keySpec);
		
		Cipher cipher = Cipher.getInstance("RSA/ECB/PKCS1Padding");
		cipher.init(Cipher.ENCRYPT_MODE, publicKey);
		
		byte[] pt = accountNo.getBytes();
		byte[] ct = cipher.doFinal(pt);
		
		return Base64.encodeBase64String(ct);
	}
	
	public URL getResource(String resource){

	    URL url ;

	    //Try with the Thread Context Loader. 
	    ClassLoader classLoader = Thread.currentThread().getContextClassLoader();
	    if(classLoader != null){
	        url = classLoader.getResource(resource);
	        if(url != null){
	            return url;
	        }
	    }

	    //Let's now try with the classloader that loaded this class.
	    classLoader = SecureTanServiceImpl.class.getClassLoader();
	    if(classLoader != null){
	        url = classLoader.getResource(resource);
	        if(url != null){
	            return url;
	        }
	    }

	    //Last ditch attempt. Get the resource from the classpath.
	    return ClassLoader.getSystemResource(resource);
	}

}
