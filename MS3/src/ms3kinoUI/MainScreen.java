package ms3kinoUI;

import Extras.Window;
import javafx.scene.control.ComboBox;
import ms3extras.MongoConnector;

import java.net.ConnectException;
import java.sql.SQLException;
import java.text.ParseException;
import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class MainScreen extends Window {
    private JButton importAllFromCinebaseButton;
    private JPanel mainPanel;
    private JComboBox comboBox1;
    private JButton manualDataEntryButton;
    private JButton dropDatabaseButton;
    public JProgressBar importProgressBar;
    public JProgressBar dropProgressBar;
    private JButton viewStatsButton;

    MainScreen() {
        run(mainPanel);
        manualDataEntryButton.addActionListener(e -> {
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
        importAllFromCinebaseButton.addActionListener(e -> {
            try {
                new SQLMigrator(importProgressBar).migrateAll();
            } catch (Exception e1) {
                e1.printStackTrace();
            }
        });
        dropDatabaseButton.addActionListener(e -> {
            MongoConnector.cinebase.drop();
            dropProgressBar.setValue(dropProgressBar.getMaximum());
            JOptionPane.showMessageDialog(null, "Successfully dropped Cinebase!");
        });
    }
}
