package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class TicketEntry extends Window {
    private JPanel ticketPanel;
    private JTextField ticketIDField;
    private JTextField screeningIDField;
    private JTextField customerIDField;
    private JTextField priceField;
    private JTextField discountTypeField;
    private JButton backButton;
    private JButton submitButton;

    public TicketEntry(final Connection conn) {
        run(ticketPanel);
        backButton.addActionListener(e -> frame.setVisible(false));
        submitButton.addActionListener(e -> {
            try {
                Statement ProgrammInsertStmt = conn.createStatement();
                ProgrammInsertStmt.executeUpdate("INSERT INTO ticket VALUES(" + Integer.valueOf(ticketIDField.getText()) + ", " + Integer.valueOf(screeningIDField.getText()) + ", " + Integer.valueOf(customerIDField.getText()) + ", " + Integer.valueOf(priceField.getText()) + ", '" + discountTypeField.getText() + "')");
                JOptionPane.showMessageDialog(null, "Success!");
            } catch (SQLException sqle) {
                JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                System.out.println(sqle.getMessage());
            }
        });
    }
}
