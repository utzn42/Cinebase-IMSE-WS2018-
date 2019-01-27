package ms3kinoUI;

import ms3extras.MongoConnector;

import javax.swing.*;
import java.awt.*;

public class StartScreen {
    public static JFrame frame = new JFrame("Kino JDBC (MongoDB)");
    private JPanel loginPanel;
    private JTextField usernameField;
    private JPasswordField passwordField;
    private JButton submitButton;

    private StartScreen() {

        submitButton.addActionListener(e -> {
            MongoConnector.connect(usernameField.getText(), String.valueOf(passwordField.getPassword()));
            frame.setVisible(false);
            new MainScreen().frame.setVisible(true);
        });
    }

    public static void main(String[] args) {
        Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
        int width = screenSize.width / 3;
        int height = screenSize.height / 3;
        frame.setPreferredSize(new Dimension(width, height));
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setContentPane(new StartScreen().loginPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }
}
