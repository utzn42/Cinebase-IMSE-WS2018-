package extras;

import KinoUI.KinoJDBC_LoginFrame;

import javax.swing.*;
import java.awt.*;

public abstract class Window {

    public JFrame frame = new JFrame("Kino JDBC");
    public JPanel mainPanel;

    public void run(JPanel panel) {
        frame.setPreferredSize(new Dimension(KinoJDBC_LoginFrame.width, KinoJDBC_LoginFrame.height));
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setContentPane(panel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }
}
