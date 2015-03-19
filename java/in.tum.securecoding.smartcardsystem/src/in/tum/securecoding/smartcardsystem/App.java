package in.tum.securecoding.smartcardsystem;

import in.tum.securecoding.smartcardsystem.services.ILoginService;
import in.tum.securecoding.smartcardsystem.services.ISecureTANService;
import in.tum.securecoding.smartcardsystem.services.impl.LoginServiceImpl;
import in.tum.securecoding.smartcardsystem.services.impl.SecureTanServiceImpl;
import in.tum.securecoding.team5.smartcardsystem.control.listeners.GenerateTANListener;
import in.tum.securecoding.team5.smartcardsystem.control.listeners.OnlyNumberInputListener;
import org.eclipse.swt.SWT;
import org.eclipse.swt.graphics.Rectangle;
import org.eclipse.swt.layout.GridData;
import org.eclipse.swt.layout.GridLayout;
import org.eclipse.swt.layout.RowLayout;
import org.eclipse.swt.widgets.Button;
import org.eclipse.swt.widgets.Composite;
import org.eclipse.swt.widgets.Display;
import org.eclipse.swt.widgets.Group;
import org.eclipse.swt.widgets.Label;
import org.eclipse.swt.widgets.Listener;
import org.eclipse.swt.widgets.Monitor;
import org.eclipse.swt.widgets.Shell;
import org.eclipse.swt.widgets.Text;
import org.mihalis.opal.login.LoginDialog;
import org.mihalis.opal.login.LoginDialogVerifier;
import org.mihalis.opal.titledSeparator.TitledSeparator;

public class App {

	private Text txtAnotherTest;
	private ISecureTANService tanService;
	private ILoginService loginService;
	private static Display display;

	public App() {
		tanService = new SecureTanServiceImpl();
		loginService = new LoginServiceImpl();
	}

	public static void main(String[] args) {
		display = new Display();

		// Shell shell = new Shell(display);
		final Shell shell = new Shell(display);
		shell.setBounds(200, 200, 800, 340);
		// new App().postContextCreate(shell);
		new App().createComposite(shell);

		shell.open();
		while (!shell.isDisposed()) {
			if (!display.readAndDispatch())
				display.sleep();
		}
		display.dispose();
	}

	public void createComposite(final Composite parent) {

		LoginDialog dialog = new LoginDialog();
		final LoginDialogVerifier verifier = new LoginDialogVerifier() {

			@Override
			public void authenticate(final String login, final String password) throws Exception {
				if ("".equals(login)) {
					throw new Exception("Please enter a login.");
				}

				if ("".equals(password)) {
					throw new Exception("Please enter a password.");
				}

				if (loginService != null) {
					if (!loginService.login(login, password)) {
						throw new Exception("Login Failed");
					}
				}

			}
		};

		dialog.setVerifier(verifier);
		if (dialog.open()) {
			setLocation(display, parent.getShell());

			String license = null;
			String decryptedLicense = null;

			Listener onlyNumberListener = new OnlyNumberInputListener();

			// of different size
			GridLayout layout = new GridLayout(2, false);

			// set the layout to the shell
			parent.setLayout(layout);

			// create a label and a button
			Label label = new Label(parent, SWT.NONE);

			// create a new label that will span two columns
			final TitledSeparator sep1 = new TitledSeparator(parent, SWT.NONE);
			sep1.setLayoutData(new GridData(GridData.FILL, GridData.FILL, true, false));
			sep1.setText("Transaction Info");
			// create new layout data
			GridData data = new GridData(SWT.FILL, SWT.TOP, true, false, 2, 1);
			label.setLayoutData(data);

			// create new layout data
			data = new GridData(SWT.FILL, SWT.TOP, true, false);
			data.horizontalSpan = 2;
			label.setLayoutData(data);

			data = new GridData(SWT.LEFT, SWT.TOP, false, false, 2, 1);
			GridData gridData = new GridData(SWT.FILL, SWT.FILL, true, false);
			gridData.widthHint = SWT.DEFAULT;
			gridData.heightHint = SWT.DEFAULT;
			gridData.horizontalSpan = 2;

			Composite composite = new Composite(parent, SWT.BORDER);
			gridData = new GridData(SWT.FILL, SWT.FILL, true, false);
			gridData.horizontalSpan = 2;
			composite.setLayoutData(gridData);
			composite.setLayout(new GridLayout(1, false));

			final Text txtTest = new Text(composite, SWT.NONE);
			txtTest.setMessage("Enter Account No (14 Digits)");
			gridData = new GridData(SWT.FILL, SWT.FILL, true, false);
			txtTest.setLayoutData(gridData);
			txtTest.addListener(SWT.Verify, onlyNumberListener);

			final Text txtMoreTests = new Text(composite, SWT.NONE);
			txtMoreTests.setMessage("Enter Amount (Optional)");
			gridData = new GridData(SWT.FILL, SWT.FILL, true, false);
			txtMoreTests.setLayoutData(gridData);
			txtMoreTests.addListener(SWT.Verify, onlyNumberListener);

			// final OButton button2 = new OButton(parent, SWT.PUSH);
			Button button2 = new Button(parent, SWT.PUSH);
			button2.setText("Generate");
			button2.setLayoutData(new GridData(GridData.CENTER, GridData.CENTER, true, false));
			// button2.setButtonRenderer(DefaultButtonRenderer.getInstance());

			final Label label2 = new Label(parent, SWT.NONE);

			final TitledSeparator sep12 = new TitledSeparator(parent, SWT.NONE);
			sep12.setLayoutData(new GridData(GridData.FILL, GridData.FILL, true, false));
			sep12.setText("Secure TAN");

			Group group = new Group(parent, SWT.NONE);
			gridData = new GridData(SWT.FILL, SWT.FILL, true, false);
			gridData.horizontalSpan = 2;
			group.setLayoutData(gridData);
			group.setLayout(new RowLayout(SWT.VERTICAL));
			txtAnotherTest = new Text(group, SWT.NONE);
			txtAnotherTest.setSize(800, 20);
			txtAnotherTest
					.setText("---------------------------------------------------------YOUR SECURE TAN WILL BE DISPLAYED HERE----------------------------------------------------------");

			button2.addSelectionListener(new GenerateTANListener(tanService, txtTest, txtAnotherTest));
		} else
			try {
				display.dispose();
			} catch (Exception e) {

			}
	}

	public void postContextCreate(final Shell shell) {

		LoginDialog dialog = new LoginDialog();
		final LoginDialogVerifier verifier = new LoginDialogVerifier() {

			@Override
			public void authenticate(final String login, final String password) throws Exception {
				if ("".equals(login)) {
					throw new Exception("Please enter a login.");
				}

				if ("".equals(password)) {
					throw new Exception("Please enter a password.");
				}

				if (loginService != null) {
					if (!loginService.login(login, password)) {
						throw new Exception("Login Failed");
					}
				}

			}
		};

		dialog.setVerifier(verifier);

		// position the shell
		setLocation(display, shell);

	}

	private void setLocation(Display display, Shell shell) {
		Monitor monitor = display.getPrimaryMonitor();
		Rectangle monitorRect = monitor.getBounds();
		Rectangle shellRect = shell.getBounds();
		int x = monitorRect.x + (monitorRect.width - shellRect.width) / 2;
		int y = monitorRect.y + (monitorRect.height - shellRect.height) / 2;
		shell.setLocation(x, y);
	}
}