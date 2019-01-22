package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;
import org.bson.types.ObjectId;

import javax.swing.*;

import static com.mongodb.client.model.Filters.eq;

public class ScreeningEntry extends Window {
    private JTextField idField;
    private JTextField hallidField;
    private JTextField filmidField;
    private JTextField timeField;
    private JButton submitButton;
    private JPanel screeningPanel;
    private JButton backButton;

    public ScreeningEntry() {
        run(screeningPanel);
        submitButton.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("films");

            Document screening;

            if (idField.getText().equals("")) {
                screening = new Document("hall_id", hallidField.getText())
                        .append("film_id", filmidField.getText())
                        .append("starting_time", timeField.getText());
            } else {
                screening = new Document("_id", idField.getText())
                        .append("hall_id", hallidField.getText())
                        .append("film_id", filmidField.getText())
                        .append("starting_time", timeField.getText());
            }

            collection.updateOne(eq("_id", new ObjectId(filmidField.getText())), new Document("$push", new Document("screenings", screening)));

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
