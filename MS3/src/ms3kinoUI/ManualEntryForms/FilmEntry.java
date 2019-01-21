package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;

import javax.swing.*;

public class FilmEntry extends Window {
    private JPanel filmPanel;
    private JTextField titleField;
    private JTextField directorField;
    private JTextField countryField;
    private JTextField languageField;
    private JTextField ratingField;
    private JTextField durationField;
    private JButton submitButton;

    public FilmEntry() {
        run(filmPanel);
        submitButton.addActionListener(e -> {

            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("film");

            Document doc = new Document("title", titleField.getText())
                    .append("director", directorField.getText())
                    .append("country", countryField.getText())
                    .append("language", languageField.getText())
                    .append("rating", ratingField.getText())
                    .append("duration", durationField.getText());

            collection.insertOne(doc);

            JOptionPane.showMessageDialog(null, "Success!");
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
    }
}
