package KinoUI.ManualEntryForms;

import Extras.Window;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class FilmEntry extends Window {
    private JPanel programmPanel;
    private JTextField idField;
    private JTextField directorField;
    private JTextField titleField;
    private JButton submitButton;
    private JButton backButton;
    private JTextField countryField;
    private JTextField languageField;
    private JTextField ageField;

    public FilmEntry(final Connection conn) {
        run(programmPanel);
        submitButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                try {
                    Statement ProgrammInsertStmt = conn.createStatement();
                    ProgrammInsertStmt.executeUpdate("INSERT INTO film VALUES(" + Integer.valueOf(idField.getText()) + ", '" + titleField.getText() + "', '" + directorField.getText() + "', '" + countryField.getText() + "', '" + languageField.getText() + "', " + Integer.valueOf(ageField.getText()) + ")");
                    JOptionPane.showMessageDialog(null, "Success!");
                } catch (SQLException sqle) {
                    JOptionPane.showMessageDialog(null, "Encountered error while executing SQL statement");
                    System.out.println(sqle.getMessage());
                }
            }
        });
        backButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                frame.setVisible(false);
            }
        });
    }
}
