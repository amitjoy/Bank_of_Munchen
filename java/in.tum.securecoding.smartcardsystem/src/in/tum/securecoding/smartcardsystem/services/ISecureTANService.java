package in.tum.securecoding.smartcardsystem.services;

import java.io.IOException;
import java.net.URISyntaxException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.spec.InvalidKeySpecException;

import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;

public interface ISecureTANService {

	public String generate(String accountNo)
			throws NoSuchAlgorithmException, NoSuchPaddingException,
 InvalidKeyException,
			IllegalBlockSizeException, BadPaddingException,
			InvalidKeySpecException, IOException, URISyntaxException;

}
