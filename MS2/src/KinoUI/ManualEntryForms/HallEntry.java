package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class HallEntry extends Window {
    private JPanel hallPanel;
    private JTextField idField;
    private JTextField nameField;
    private JTextField equipField;
    private JButton backButton;
    private JButton submitButton;

    public HallEntry(final Connection conn) {
        run(hallPanel);
        backButton.addActionListener(e -> frame.setVisible(false));
        submitButton.addActionListener(e -> {
            try {
                Statement ProgrammInsertStmt = conn.createStatement();
                ProgrammInsertStmt.executeUpdate("INSERT INTO hall VALUES(" + Integer.valueOf(idField.getText()) + ", '" + nameField.getText() + "', '" + equipField.getText() + "')");
                JOptionPane.showMessageDialog(null, "Success!");
            } catch (SQLException sqle) {
                JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                System.out.println(sqle.getMessage());
            }
        });
    }
}
