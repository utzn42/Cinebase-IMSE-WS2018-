package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;

import javax.swing.*;

public class ScreeningEntry extends Window {
    private JTextField idField;
    private JTextField hallidField;
    private JTextField filmidField;
    private JTextField timeField;
    private JButton submitButton;
    private JPanel screeningPanel;

    public ScreeningEntry() {
        run(screeningPanel);
        submitButton.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("screenings");
            Document doc;
            if (idField.getText().equals("")) {
                doc = new Document("hall_id", hallidField.getText())
                        .append("film_id", filmidField.getText())
                        .append("starting_time", timeField.getText());
            } else {
                doc = new Document("_id", idField.getText())
                        .append("hall_id", hallidField.getText())
                        .append("film_id", filmidField.getText())
                        .append("starting_time", timeField.getText());
            }

            collection.insertOne(doc);

            JOptionPane.showMessageDialog(null, "Success!");
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
    }
}
