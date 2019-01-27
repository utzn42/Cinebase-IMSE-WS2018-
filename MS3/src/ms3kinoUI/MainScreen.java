package ms3kinoUI;

import Extras.Window;
import ms3extras.MongoConnector;
import ms3kinoUI.Stats.CollectionStatsScreen;
import ms3kinoUI.Stats.GeneralStatsScreen;

import javax.swing.*;

public class MainScreen extends Window {
    public JProgressBar importProgressBar;
    public JProgressBar dropProgressBar;
    private JButton importAllFromCinebaseButton;
    private JPanel mainPanel;
    private JComboBox comboBox1;
    private JButton manualDataEntryButton;
    private JButton dropDatabaseButton;
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
                JOptionPane.showMessageDialog(null, "Error. Database has already been imported!");
            }
        });
        dropDatabaseButton.addActionListener(e -> {
            MongoConnector.cinebase.drop();
            dropProgressBar.setValue(dropProgressBar.getMaximum());
            JOptionPane.showMessageDialog(null, "Successfully dropped Cinebase!");
        });
        viewStatsButton.addActionListener(e -> {
            if (comboBox1.getSelectedItem() == "General") {
                new GeneralStatsScreen().frame.setVisible(true);
            } else {
                new CollectionStatsScreen().frame.setVisible(true);
            }
        });
    }
}
