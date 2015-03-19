package in.tum.securecoding.team5.smartcardsystem.control.listeners;

import org.eclipse.swt.widgets.Event;
import org.eclipse.swt.widgets.Listener;
import org.mihalis.opal.opalDialog.Dialog;

public class AccountNoLengthListener implements Listener {

	@Override
	public void handleEvent(Event e) {
		String string = e.text;
		if (string != null)
			if (string.length() != 14) {
				Dialog.error("Error", "Account No must be 14 digits in legth");
				return;
			}

	}

}
