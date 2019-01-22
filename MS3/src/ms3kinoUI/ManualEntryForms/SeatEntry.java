package ms3kinoUI.ManualEntryForms;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import ms3kinoUI.DataEntryChooser;
import org.bson.Document;
import org.bson.types.ObjectId;

import javax.swing.*;

import static com.mongodb.client.model.Filters.eq;

public class SeatEntry extends Window {
    private JTextField idField;
    private JTextField hallidField;
    private JTextField seatnrField;
    private JButton submitButton;
    private JButton backButton;
    private JTextField rowNrField;
    private JPanel seatPanel;

    public SeatEntry() {
        run(seatPanel);
        backButton.addActionListener(e -> {
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
        submitButton.addActionListener(e -> {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("halls");

            Document seat;

            if (idField.getText().equals("")) {
                seat = new Document("hall_id", hallidField.getText())
                        .append("seat_nr", seatnrField.getText())
                        .append("row_nr", rowNrField.getText());
            } else {
                seat = new Document("_id", idField.getText())
                        .append("hall_id", hallidField.getText())
                        .append("seat_nr", seatnrField.getText())
                        .append("row_nr", rowNrField.getText());
            }


            try {
                collection.updateOne(eq("_id", new ObjectId(hallidField.getText())), new Document("$push", new Document("seats", seat)));
            } catch (Exception e1) {
                collection.updateOne(eq("_id", hallidField.getText()), new Document("$push", new Document("seats", seat)));
            }

            JOptionPane.showMessageDialog(null, "Success!");
            frame.setVisible(false);
            new DataEntryChooser().frame.setVisible(true);
        });
    }
}
