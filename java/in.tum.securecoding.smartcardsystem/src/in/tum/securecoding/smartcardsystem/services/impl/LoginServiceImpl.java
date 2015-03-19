package in.tum.securecoding.smartcardsystem.services.impl;

import in.tum.securecoding.smartcardsystem.services.ILoginService;

import com.google.common.hash.Hashing;

public class LoginServiceImpl implements ILoginService {

	@Override
	public boolean login(String userName, String password) {
		
		if (userName != null) {
			final String hashed = Hashing.sha256().hashBytes(userName.getBytes())
			        .toString();

			if (password != null) {
				return password.equals(hashed);
			}
		}
		return false;
	}

}
