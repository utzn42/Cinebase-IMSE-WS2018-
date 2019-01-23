package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;

import javax.swing.*;

public class EmployeeEntry extends Window {
    private JPanel employeePanel;
    private JTextField idField;
    private JTextField manageridField;
    private JTextField firstnameField;
    private JTextField lastnameField;
    private JTextField emailField;
    private JTextField passwordField;
    private JButton submitButton;
    private JButton backButton;

    public EmployeeEntry() {
        run(employeePanel);
        backButton.addActionListener(e -> {
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
        submitButton.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("employees");

            Document doc;
            if (idField.getText().equals("")) {
                doc = new Document("manager_id", manageridField.getText())
                        .append("first_name", firstnameField.getText())
                        .append("last_name", lastnameField.getText())
                        .append("email", emailField.getText())
                        .append("password", passwordField.getText());
            } else {
                doc = new Document("_id", idField.getText())
                        .append("manager_id", manageridField.getText())
                        .append("first_name", firstnameField.getText())
                        .append("last_name", lastnameField.getText())
                        .append("email", emailField.getText())
                        .append("password", passwordField.getText());
            }

            collection.insertOne(doc);

            JOptionPane.showMessageDialog(null, "Success!");
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
    }
}
