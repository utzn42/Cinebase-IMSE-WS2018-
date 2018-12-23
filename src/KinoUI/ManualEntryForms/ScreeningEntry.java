package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class ScreeningEntry extends Window {
    private JPanel screeningPanel;
    private JTextField screeningIDField;
    private JTextField hallIDField;
    private JTextField filmIDField;
    private JTextField starttimeField;
    private JTextField durationField;
    private JButton backButton;
    private JButton submitButton;

    public ScreeningEntry(final Connection conn) {
        run(screeningPanel);
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
                    ProgrammInsertStmt.executeUpdate("INSERT INTO screening VALUES(" + Integer.valueOf(screeningIDField.getText()) + ", " + Integer.valueOf(hallIDField.getText()) + ", " + Integer.valueOf(filmIDField.getText()) + ", '" + starttimeField.getText() + "', " + Integer.valueOf(durationField.getText()) + ")");
                    JOptionPane.showMessageDialog(null, "Success!");
                } catch (SQLException sqle) {
                    JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                    System.out.println(sqle.getMessage());
                }
            }
        });
    }
}
