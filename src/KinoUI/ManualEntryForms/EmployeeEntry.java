package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class EmployeeEntry extends Window {
    private JPanel employeePanel;
    private JTextField employeeNoField;
    private JTextField managerIDField;
    private JTextField firstnameField;
    private JTextField lastnameField;
    private JTextField emailField;
    private JButton backButton;
    private JButton submitButton;

    public EmployeeEntry(final Connection conn) {
        run(employeePanel);
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
                    ProgrammInsertStmt.executeUpdate("INSERT INTO employee VALUES(" + Integer.valueOf(employeeNoField.getText()) + ", " + Integer.valueOf(managerIDField.getText()) + ", '" + firstnameField.getText() + "', '" + lastnameField.getText() + "', '" + emailField.getText() + "')");
                    JOptionPane.showMessageDialog(null, "Success!");
                } catch (SQLException sqle) {
                    JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                    System.out.println(sqle.getMessage());
                }
            }
        });
    }
}
