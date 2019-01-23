package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;

import javax.swing.*;
import java.util.Collections;

public class CustomerEntry extends Window {
    private JButton backButton;
    private JButton submitButton;
    private JTextField passwordField;
    private JTextField emailField;
    private JTextField typeField;
    private JTextField idField;
    private JPanel customerPanel;

    public CustomerEntry() {
        run(customerPanel);
        backButton.addActionListener(e -> {
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
        submitButton.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("customers");

            Document doc;
            if (idField.getText().equals("")) {
                doc = new Document("customer_type", typeField.getText())
                        .append("email", emailField.getText())
                        .append("password", passwordField.getText())
                        .append("tickets", Collections.emptyList());
            } else {
                doc = new Document("_id", idField.getText())
                        .append("customer_type", typeField.getText())
                        .append("email", emailField.getText())
                        .append("password", passwordField.getText())
                        .append("tickets", Collections.emptyList());
            }

            collection.insertOne(doc);

            JOptionPane.showMessageDialog(null, "Success!");
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
    }
}
