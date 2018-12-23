package KinoUI;

import Extras.Window;
import KinoUI.ManualEntryForms.FilmEntry;
import KinoUI.ManualEntryForms.HallEntry;
import KinoUI.ManualEntryForms.ScreeningEntry;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
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
    private JButton deineMutterButton;
    private JButton backButton;

    public KinoJDBC_ManualEntryWindow(final Connection conn) {
        run(manualEntryPanel);

        backButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                frame.setVisible(false);
                new KinoJDBC_MainWindow(conn).frame.setVisible(true);
            }
        });
        filmButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                new FilmEntry(conn).frame.setVisible(true);
            }
        });
        hallButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                new HallEntry(conn).frame.setVisible(true);
            }
        });
        screeningButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                new ScreeningEntry(conn).frame.setVisible(true);
            }
        });
    }

}
