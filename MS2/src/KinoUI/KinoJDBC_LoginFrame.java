package KinoUI;

import Extras.Window;
import SQLHandling.ConnectionHandler;
import SQLHandling.LoginDataProvider;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.net.ConnectException;
import java.sql.Connection;

public class KinoJDBC_LoginFrame extends Window {
    public static JFrame frame = new JFrame("Kino JDBC");
    private static Connection conn;
    private JPanel loginPanel;
    private JTextField userNameTextField;
    private JLabel userNameLabel;
    private JPasswordField passwordField1;
    private JButton submitButton;

    public KinoJDBC_LoginFrame() {
        submitButton.addActionListener(e -> {
            String pass = new String(passwordField1.getPassword());
            int passHash = pass.hashCode();
            if (userNameTextField.getText().hashCode() == LoginDataProvider.getUserHash() && passHash == LoginDataProvider.getPassHash()) {
                try {
                    conn = ConnectionHandler.connect();
                    frame.setVisible(false);
                    new KinoJDBC_MainWindow(conn).frame.setVisible(true);
                } catch (ConnectException ce) {
                    JOptionPane.showMessageDialog(null, "Invalid database URL.");
                    System.out.println(ce.getMessage());
                }
            } else {
                JOptionPane.showMessageDialog(null, "Wrong username/password combination");
            }
        });
    }

    public static void main(String[] args) {
        Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
        int width = screenSize.width / 3;
        int height = screenSize.height / 3;
        frame.setPreferredSize(new Dimension(width, height));
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setContentPane(new KinoJDBC_LoginFrame().loginPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }
}
