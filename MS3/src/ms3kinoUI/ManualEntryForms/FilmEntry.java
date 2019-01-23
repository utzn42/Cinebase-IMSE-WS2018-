package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;

import javax.swing.*;
import java.util.Collections;

public class FilmEntry extends Window {
    private JPanel filmPanel;
    private JTextField titleField;
    private JTextField directorField;
    private JTextField countryField;
    private JTextField languageField;
    private JTextField ratingField;
    private JTextField durationField;
    private JButton submitButton;
    private JTextField idField;
    private JButton backButton;

    public FilmEntry() {
        run(filmPanel);
        submitButton.addActionListener(e -> {

            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("films");

            Document doc;
            if (idField.getText().equals("")) {
                doc = new Document("title", titleField.getText())
                        .append("director", directorField.getText())
                        .append("country", countryField.getText())
                        .append("language", languageField.getText())
                        .append("rating", ratingField.getText())
                        .append("duration", durationField.getText())
                        .append("screenings", Collections.emptyList());
            } else {
                doc = new Document("_id", idField.getText())
                        .append("title", titleField.getText())
                        .append("director", directorField.getText())
                        .append("country", countryField.getText())
                        .append("language", languageField.getText())
                        .append("rating", ratingField.getText())
                        .append("duration", durationField.getText())
                        .append("screenings", Collections.emptyList());
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
