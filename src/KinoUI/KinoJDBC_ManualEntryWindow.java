package KinoUI;

import extras.Window;

import javax.swing.*;
import java.sql.Connection;

public class KinoJDBC_ManualEntryWindow extends Window {
    private JPanel manualEntryPanel;
    private JLabel tableSelectLabel;
    private JButton programmButton;
    private JButton filmButton;
    private JButton sondervorstellungButton;
    private JButton saalButton;
    private JButton vorführungButton;
    private JButton sitzButton;
    private JButton ticketButton;
    private JButton mitarbeiterButton;
    private JButton aufsichtButton;

    public KinoJDBC_ManualEntryWindow(Connection conn) {
        run(manualEntryPanel);
    }

}
