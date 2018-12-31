package KinoUI;

import Extras.Window;
import SQLHandling.SQLScriptLoader;

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
                SQLScriptLoader.performLoadScript(conn, "C:\\Users\\utzn\\Google Drive\\Uni Wien\\WS 2018-19\\ISE\\Projekt\\Kino_JDBC\\scripts\\drop.sql");
            }
        });
        createTablesButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                SQLScriptLoader.performLoadScript(conn, "C:\\Users\\utzn\\Google Drive\\Uni Wien\\WS 2018-19\\ISE\\Projekt\\Kino_JDBC\\scripts\\create.sql");
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
}
