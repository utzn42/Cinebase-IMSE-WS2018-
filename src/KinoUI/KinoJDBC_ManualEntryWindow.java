package KinoUI;

import Extras.Window;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;

public class KinoJDBC_ManualEntryWindow extends Window {
    private Connection conn;
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
    }

}
