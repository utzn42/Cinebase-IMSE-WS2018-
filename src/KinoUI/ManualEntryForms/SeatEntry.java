package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class SeatEntry extends Window {
    private JPanel seatPanel;
    private JTextField hallIDField;
    private JTextField noField;
    private JTextField rowField;
    private JButton backButton;
    private JButton submitButton;

    public SeatEntry(final Connection conn) {
        run(seatPanel);
        backButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                frame.setVisible(false);
            }

        });
        submitButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                try {
                    Statement ProgrammInsertStmt = conn.createStatement();
                    ProgrammInsertStmt.executeUpdate("INSERT INTO seat VALUES(" + "NULL, " + Integer.valueOf(hallIDField.getText()) + ", " + Integer.valueOf(noField.getText()) + ", " + Integer.valueOf(rowField.getText()) + ")");
                    JOptionPane.showMessageDialog(null, "Success!");
                } catch (SQLException sqle) {
                    JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                    System.out.println(sqle.getMessage());
                }
            }
        });
    }
}
