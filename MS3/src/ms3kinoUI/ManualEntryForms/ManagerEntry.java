package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;
import org.bson.types.ObjectId;

import javax.swing.*;

import static com.mongodb.client.model.Filters.eq;

public class ManagerEntry extends Window {
    private JButton submitButton;
    private JButton backButton;
    private JTextField idField;
    private JTextField manageridField;
    private JPanel managerPanel;

    public ManagerEntry() {
        run(managerPanel);
        submitButton.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("employees");

            try {
                collection.updateOne(eq("_id", new ObjectId(idField.getText())), new Document("$push", new Document("manager_id", manageridField.getText())));
            } catch (Exception e1) {
                collection.updateOne(eq("_id", idField.getText()), new Document("$set", new Document("manager_id", manageridField.getText())));
            }

            JOptionPane.showMessageDialog(null, "Success!");
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
        backButton.addActionListener(e -> {
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
    }
}
