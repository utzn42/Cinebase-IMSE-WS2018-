package ms3kinoUI;

import Extras.Window;

import java.net.ConnectException;
import java.sql.SQLException;
import java.text.ParseException;
import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class MainScreen extends Window {
    private JButton importAllFromCinebaseButton;
    private JPanel mainPanel;
    private JButton manualDataEntryButton;

    public MainScreen() {
        run(mainPanel);
        manualDataEntryButton.addActionListener(e -> {
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
        importAllFromCinebaseButton.addActionListener(e -> {
            frame.setVisible(false);
            try {
                new SQLMigrator().migrateAll();
            } catch (ConnectException e1) {
                e1.printStackTrace();
            } catch (SQLException e1) {
                e1.printStackTrace();
            } catch (ParseException e1) {
                e1.printStackTrace();
            }
        });
    }
}
