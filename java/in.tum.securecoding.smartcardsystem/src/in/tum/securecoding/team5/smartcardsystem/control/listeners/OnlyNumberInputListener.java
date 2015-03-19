package in.tum.securecoding.team5.smartcardsystem.control.listeners;

import org.eclipse.swt.widgets.Event;
import org.eclipse.swt.widgets.Listener;

public class OnlyNumberInputListener implements Listener {

	@Override
	public void handleEvent(Event e) {
		String string = e.text;
		char[] chars = new char[string.length()];
		string.getChars(0, chars.length, chars, 0);
		for (int i = 0; i < chars.length; i++) {
			if (!('0' <= chars[i] && chars[i] <= '9')) {
				e.doit = false;
				return;
			}
		}
	}

}
