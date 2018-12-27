package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class SupervisionEntry extends Window {
    private JPanel supervisionPanel;
    private JButton button1;
    private JButton button2;
    private JTextField hallIDField;
    private JTextField supervisorIDField;

    public SupervisionEntry(final Connection conn) {
        run(supervisionPanel);
        button1.addActionListener(e -> frame.setVisible(false));
        button2.addActionListener(e -> {
            try {
                Statement ProgrammInsertStmt = conn.createStatement();
                ProgrammInsertStmt.executeUpdate("INSERT INTO supervision VALUES(" + Integer.valueOf(hallIDField.getText()) + ", " + Integer.valueOf(supervisorIDField.getText()) + ")");
                JOptionPane.showMessageDialog(null, "Success!");
            } catch (SQLException sqle) {
                JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                System.out.println(sqle.getMessage());
            }
        });
    }
}
