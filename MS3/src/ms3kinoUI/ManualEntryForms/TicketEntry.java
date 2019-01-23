package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;
import org.bson.types.ObjectId;

import javax.swing.*;

import static com.mongodb.client.model.Filters.eq;

public class TicketEntry extends Window {
    private JButton backButton;
    private JButton submitButton;
    private JTextField typeField;
    private JTextField priceField;
    private JTextField customeridField;
    private JTextField screeningidField;
    private JTextField idField;
    private JPanel ticketPanel;

    public TicketEntry() {
        run(ticketPanel);
        backButton.addActionListener(e -> {
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
        submitButton.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("customers");

            Document ticket;

            if (idField.getText().equals("")) {
                ticket = new Document("screening_id", screeningidField.getText())
                        .append("customer_id", customeridField.getText())
                        .append("price", priceField.getText())
                        .append("discount_type", typeField.getText());
            } else {
                ticket = new Document("_id", idField.getText())
                        .append("screening_id", screeningidField.getText())
                        .append("customer_id", customeridField.getText())
                        .append("price", priceField.getText())
                        .append("discount_type", typeField.getText());
            }

            try {
                collection.updateOne(eq("_id", new ObjectId(customeridField.getText())), new Document("$push", new Document("tickets", ticket)));
            } catch (Exception e1) {
                collection.updateOne(eq("_id", customeridField.getText()), new Document("$push", new Document("tickets", ticket)));
            }

            JOptionPane.showMessageDialog(null, "Success!");
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
    }
}
