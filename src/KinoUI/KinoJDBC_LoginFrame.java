package KinoUI;

import SQLHandling.ConnectionHandler;
import SQLHandling.LoginDataProvider;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class KinoJDBC_LoginFrame {
    public static Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
    public static int height = screenSize.height / 4;
    public static int width = screenSize.width / 4;
    static JFrame frame = new JFrame("Kino JDBC");

    private JPanel loginPanel;
    private JTextField userNameTextField;
    private JLabel userNameLabel;
    private JPasswordField passwordField1;
    private JButton submitButton;

    public KinoJDBC_LoginFrame() {
        submitButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String pass = new String(passwordField1.getPassword());
                int passHash = pass.hashCode();
                if (userNameTextField.getText().hashCode() == LoginDataProvider.getUserHash() && passHash == LoginDataProvider.getPassHash()) {
                    ConnectionHandler.connect();
                    frame.setVisible(false);
                    new KinoJDBC_MainWindow().frame.setVisible(true);

                } else
                    JOptionPane.showMessageDialog(null, "Wrong username/password combination");
            }
        });
    }

    public static void main(String[] args) throws Exception {
        Class.forName("com.mysql.jdbc.Driver");
        frame.setPreferredSize(new Dimension(width, height));
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setContentPane(new KinoJDBC_LoginFrame().loginPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }
}
