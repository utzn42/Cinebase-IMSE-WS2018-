package ms3kinoUI;

import Extras.Window;
import ms3kinoUI.ManualEntryForms.FilmEntry;

import javax.swing.*;

public class DataEntryChooser extends Window {
    private JPanel dataEntryPanel;
    private JButton filmButton;
    private JButton hallButton;
    private JButton screeningButton;
    private JButton seatButton;
    private JButton customerButton;
    private JButton ticketButton;
    private JButton employeeButton;
    private JButton supervisionButton;
    private JButton blankButton;
    private JButton backButton;

    public DataEntryChooser() {
        run(dataEntryPanel);
        backButton.addActionListener(e -> {
            frame.setVisible(false);
            new MainScreen().frame.setVisible(true);
        });
        filmButton.addActionListener(e -> {
            frame.setVisible(false);
            new FilmEntry().frame.setVisible(true);
        });
    }
}
