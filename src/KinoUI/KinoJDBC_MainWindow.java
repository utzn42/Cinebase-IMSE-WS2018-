package KinoUI;

import SQLHandling.SQLScriptLoader;
import extras.Window;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;

public class KinoJDBC_MainWindow extends Window {
    private Connection conn;
    private JButton loadSQLScriptButton;
    private JButton manualDataEntryButton;
    private JButton dropTablesButton;
    private JPanel mainPanel;
    private JButton createTablesButton;

    public KinoJDBC_MainWindow(final Connection conn) {
        this.conn = conn;
        run(mainPanel);
        loadSQLScriptButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                SQLScriptLoader.performLoadScript(conn, null);
            }
        });
        dropTablesButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                SQLScriptLoader.performLoadScript(conn, "C:\\Users\\utzn\\Google Drive\\Uni Wien\\WS 2018-19\\ISE\\Projekt\\Kino_JDBC\\oliver_dbs\\01220194_SCHWEIGER_drop.sql");
            }
        });
        createTablesButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                SQLScriptLoader.performLoadScript(conn, "C:\\Users\\utzn\\Google Drive\\Uni Wien\\WS 2018-19\\ISE\\Projekt\\Kino_JDBC\\oliver_dbs\\01220194_SCHWEIGER_create.sql");
            }
        });
        manualDataEntryButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                frame.setVisible(false);
                new KinoJDBC_ManualEntryWindow(conn).frame.setVisible(true);
            }
        });
    }

    /*public void run() {
        frame.setPreferredSize(new Dimension(KinoJDBC_LoginFrame.width, KinoJDBC_LoginFrame.height));
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setContentPane(mainPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }*/
}
