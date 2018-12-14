package KinoUI;

import javax.swing.*;
import java.awt.*;

public class KinoJDBC {
    private JButton scriptButton;
    private JButton manualInsertButton;
    private JButton dropButton;
    private JPanel buttonPanel;

    public static void main(String[] args) {
        Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
        int height = screenSize.height / 4;
        int width = screenSize.width / 4;
        JFrame frame = new JFrame("Kino JDBC");
        frame.setPreferredSize(new Dimension(width, height));
        frame.setContentPane(new KinoJDBC().buttonPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }
}
