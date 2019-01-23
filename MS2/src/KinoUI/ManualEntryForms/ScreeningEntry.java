package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class ScreeningEntry extends Window {
    private JPanel screeningPanel;
    private JTextField hallIDField;
    private JTextField filmIDField;
    private JTextField starttimeField;
    private JButton backButton;
    private JButton submitButton;

    public ScreeningEntry(final Connection conn) {
        run(screeningPanel);
        backButton.addActionListener(e -> frame.setVisible(false));
        submitButton.addActionListener(e -> {
            try {
                Statement ProgrammInsertStmt = conn.createStatement();
                ProgrammInsertStmt.executeUpdate("INSERT INTO screening VALUES(NULL, " + Integer.valueOf(hallIDField.getText()) + ", " + Integer.valueOf(filmIDField.getText()) + ", '" + starttimeField.getText() + "')");
                JOptionPane.showMessageDialog(null, "Success!");
            } catch (SQLException sqle) {
                JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                System.out.println(sqle.getMessage());
            }
        });
    }
}
