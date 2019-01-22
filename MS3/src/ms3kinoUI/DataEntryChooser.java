package ms3kinoUI;

import Extras.Window;
import ms3kinoUI.ManualEntryForms.*;

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
        hallButton.addActionListener(e -> {
            frame.setVisible(false);
            new HallEntry().frame.setVisible(true);
        });
        screeningButton.addActionListener(e -> {
            frame.setVisible(false);
            new ScreeningEntry().frame.setVisible(true);
        });
        seatButton.addActionListener(e -> {
            frame.setVisible(false);
            new SeatEntry().frame.setVisible(true);
        });
        employeeButton.addActionListener(e -> {
            frame.setVisible(false);
            new EmployeeEntry().frame.setVisible(true);
        });
        supervisionButton.addActionListener(e -> {
            frame.setVisible(false);
            new ManagerEntry().frame.setVisible(true);
        });
        customerButton.addActionListener(e -> {
            frame.setVisible(false);
            new CustomerEntry().frame.setVisible(true);
        });
        ticketButton.addActionListener(e -> {
            frame.setVisible(false);
            new TicketEntry().frame.setVisible(true);
        });
    }
}
