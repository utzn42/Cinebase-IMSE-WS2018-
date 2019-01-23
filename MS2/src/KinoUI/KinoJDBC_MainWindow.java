package KinoUI;

import Extras.Defaults;
import Extras.Window;
import SQLHandling.SQLScriptLoader;

import javax.swing.*;
import java.sql.Connection;

public class KinoJDBC_MainWindow extends Window {
    private Connection conn;
    private JButton loadSQLScriptButton;
    private JButton manualDataEntryButton;
    private JButton dropDatabaseButton;
    private JPanel mainPanel;
    private JButton initializeDatabaseButton;

    public KinoJDBC_MainWindow(final Connection conn) {
        this.conn = conn;
        run(mainPanel);
        loadSQLScriptButton.addActionListener(e -> SQLScriptLoader.performLoadScript(conn, null));
        dropDatabaseButton.addActionListener(e -> {
            SQLScriptLoader.performLoadScript(conn, Defaults.scriptFolder + "drop_tables.sql");
            //SQLScriptLoader.performLoadScript(conn, Defaults.scriptFolder + "drop_DB.sql");                           //reconnect issue! See Defaults.databaseURL
        });
        initializeDatabaseButton.addActionListener(e -> {
            //SQLScriptLoader.performLoadScript(conn, Defaults.scriptFolder + "create_DB.sql");                         //reconnect issue! See Defaults.databaseURL
            SQLScriptLoader.performLoadScript(conn, Defaults.scriptFolder + "create_tables.sql");
            SQLScriptLoader.performLoadScript(conn, Defaults.scriptFolder + "insertAll.sql");
        });
        manualDataEntryButton.addActionListener(e -> {
            frame.setVisible(false);
            new KinoJDBC_ManualEntryWindow(conn).frame.setVisible(true);
        });
    }
}
