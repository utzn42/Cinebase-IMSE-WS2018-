package KinoUI;

import SQLHandling.SQLScriptLoader;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;

public class KinoJDBC_MainWindow {
    JFrame frame = new JFrame("Kino JDBC");
    private Connection conn;
    private JButton loadSQLScriptButton;
    private JButton manualDataEntryButton;
    private JButton dropTablesButton;
    private JPanel mainPanel;
    private JButton createTablesButton;

    public KinoJDBC_MainWindow(final Connection conn) {
        this.conn = conn;
        run();
        loadSQLScriptButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                SQLScriptLoader.performLoadScript(conn, null);
            }
        });
        dropTablesButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                SQLScriptLoader.performLoadScript(conn, "C:\\Users\\utzn\\Google Drive\\Uni Wien\\WS 2018-19\\ISE\\Projekt\\Kino_JDBC\\01220194_SCHWEIGER_DBS\\01220194_SCHWEIGER_drop.sql");
            }
        });
        createTablesButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                SQLScriptLoader.performLoadScript(conn, "C:\\Users\\utzn\\Google Drive\\Uni Wien\\WS 2018-19\\ISE\\Projekt\\Kino_JDBC\\01220194_SCHWEIGER_DBS\\01220194_SCHWEIGER_create.sql");
            }
        });
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
