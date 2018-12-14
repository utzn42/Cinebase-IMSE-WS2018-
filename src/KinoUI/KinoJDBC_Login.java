package KinoUI;

import javax.swing.*;
import java.awt.*;
import java.sql.Connection;
import java.sql.DriverManager;

public class KinoJDBC_Login {
    private JPanel loginPanel;
    private JTextField userNameTextField;
    private JLabel userNameLabel;
    private JPasswordField passwordField1;
    private JButton submitButton;

    public static void main(String[] args) throws Exception {
        Class.forName("com.mysql.jdbc.Driver");
        String database = "jdbc:mysql://localhost/kino";
        String user = "root";
        String pass = "imse2018";
        Connection con = DriverManager.getConnection(database, user, pass);
        Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
        int height = screenSize.height / 4;
        int width = screenSize.width / 4;
        JFrame frame = new JFrame("Kino JDBC");
        frame.setPreferredSize(new Dimension(width, height));
        frame.setContentPane(new KinoJDBC_Login().loginPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }
}
