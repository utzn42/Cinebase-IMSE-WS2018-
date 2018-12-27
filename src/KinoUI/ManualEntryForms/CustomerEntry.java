package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class CustomerEntry extends Window {
    private JPanel customerPanel;
    private JTextField customertypeField;
    private JTextField emailField;
    private JTextField pwField;
    private JButton backButton;
    private JButton submitButton;

    public CustomerEntry(final Connection conn) {
        run(customerPanel);
        backButton.addActionListener(e -> frame.setVisible(false));
        submitButton.addActionListener(e -> {
            try {
                Statement ProgrammInsertStmt = conn.createStatement();
                ProgrammInsertStmt.executeUpdate("INSERT INTO customer VALUES(NULL, '" + customertypeField.getText() + "', '" + emailField.getText() + "', '" + pwField.getText() + "')");
                JOptionPane.showMessageDialog(null, "Success!");
            } catch (SQLException sqle) {
                JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                System.out.println(sqle.getMessage());
            }
        });
    }
}
