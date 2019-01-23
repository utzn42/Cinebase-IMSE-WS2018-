package KinoUI;

import Extras.Window;
import KinoUI.ManualEntryForms.*;

import javax.swing.*;
import java.sql.Connection;

public class KinoJDBC_ManualEntryWindow extends Window {
    private Connection conn;
    private JPanel manualEntryPanel;
    private JLabel tableSelectLabel;
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

    KinoJDBC_ManualEntryWindow(final Connection conn) {
        run(manualEntryPanel);

        backButton.addActionListener(e -> {
            frame.setVisible(false);
            new KinoJDBC_MainWindow(conn).frame.setVisible(true);
        });
        filmButton.addActionListener(e -> new FilmEntry(conn).frame.setVisible(true));
        hallButton.addActionListener(e -> new HallEntry(conn).frame.setVisible(true));
        screeningButton.addActionListener(e -> new ScreeningEntry(conn).frame.setVisible(true));
        seatButton.addActionListener(e -> new SeatEntry(conn).frame.setVisible(true));
        customerButton.addActionListener(e -> new CustomerEntry(conn).frame.setVisible(true));
        ticketButton.addActionListener(e -> new TicketEntry(conn).frame.setVisible(true));
        employeeButton.addActionListener(e -> new EmployeeEntry(conn).frame.setVisible(true));
        supervisionButton.addActionListener(e -> new SupervisionEntry(conn).frame.setVisible(true));
    }

}
