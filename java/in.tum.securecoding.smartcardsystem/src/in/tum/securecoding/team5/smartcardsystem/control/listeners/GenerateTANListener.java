package in.tum.securecoding.team5.smartcardsystem.control.listeners;

import in.tum.securecoding.smartcardsystem.services.ISecureTANService;

import java.io.IOException;
import java.net.URISyntaxException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.spec.InvalidKeySpecException;

import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;

import org.eclipse.swt.events.SelectionEvent;
import org.eclipse.swt.events.SelectionListener;
import org.eclipse.swt.widgets.Text;
import org.mihalis.opal.opalDialog.Dialog;

public class GenerateTANListener implements SelectionListener {

	private ISecureTANService tanService;
	private Text textAccountNo;
	private Text textGeneratedTAN;

	public GenerateTANListener(ISecureTANService tanService, Text txtTest,
			Text txtAnotherTest) {
		this.tanService = tanService;
		this.textAccountNo = txtTest;
		this.textGeneratedTAN = txtAnotherTest;
	}

	@Override
	public void widgetSelected(SelectionEvent event) {

		String secureTAN = null;

		try {
			if (tanService != null) {
				if (textAccountNo != null) {
					if (textAccountNo.getText() != null) {
						if (textAccountNo.getText() != ""
								&& textAccountNo.getText().length() == 14) {
							secureTAN = tanService.generate(textAccountNo
									.getText());
						} else {
							Dialog.error("Error in Input",
									"The account no must be 14 digits long");
						}
					}
				}
			}
		} catch (InvalidKeyException | NoSuchAlgorithmException
				| NoSuchPaddingException | IllegalBlockSizeException
				| BadPaddingException | InvalidKeySpecException | IOException
				| URISyntaxException e) {
			System.out.println(e.getMessage());
		}
		if (secureTAN != null) {
			textGeneratedTAN.setText(secureTAN);
		}
	}

	@Override
	public void widgetDefaultSelected(SelectionEvent e) {
	}

}
