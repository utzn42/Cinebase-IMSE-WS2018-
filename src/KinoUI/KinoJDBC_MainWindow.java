package KinoUI;

import javax.swing.*;
import java.awt.*;

public class KinoJDBC_MainWindow {
    private JButton loadSQLScriptCreateButton;
    private JButton manualDataEntryButton;
    private JButton dropTablesButton;
    private JPanel mainPanel;
    JFrame frame = new JFrame("Kino JDBC");

    public KinoJDBC_MainWindow() {
        run();
    }

    public void run() {
        frame.setPreferredSize(new Dimension(KinoJDBC_LoginFrame.width, KinoJDBC_LoginFrame.height));
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setContentPane(mainPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }
}
