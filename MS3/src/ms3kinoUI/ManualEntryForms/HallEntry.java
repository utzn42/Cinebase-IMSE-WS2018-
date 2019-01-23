package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;

import javax.swing.*;
import java.util.Collections;

public class HallEntry extends Window {
    private JPanel hallPanel;
    private JTextField nameField;
    private JTextField equipmentField;
    private JButton button1;
    private JTextField idField;
    private JButton backButton;

    public HallEntry() {
        run(hallPanel);
        button1.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("halls");

            Document doc;
            if (idField.getText().equals("")) {
                doc = new Document("name", nameField.getText())
                        .append("equipment", equipmentField.getText())
                        .append("seats", Collections.emptyList());
            } else {
                doc = new Document("_id", idField.getText())
                        .append("name", nameField.getText())
                        .append("equipment", equipmentField.getText())
                        .append("seats", Collections.emptyList());
            }

            collection.insertOne(doc);

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
