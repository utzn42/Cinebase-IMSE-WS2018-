package ms3kinoUI.Stats;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import org.bson.Document;

import javax.swing.*;
import java.util.Iterator;

public class GeneralStatsScreen extends Window {

    private JPanel generalStatsPanel;
    private JTextField collField;
    private JTextField sizeField;
    private JTextField nameField;
    private JTextField countField;
    private JButton backButton;

    public GeneralStatsScreen() {
        run(generalStatsPanel);
        nameField.setText(MongoConnector.cinebase.getName());
        sizeField.setText("1 MB");
        collField.setText(String.valueOf(countCollections()));
        countField.setText(String.valueOf(countDataSets()));
        backButton.addActionListener(e -> frame.setVisible(false));
    }

    public GeneralStatsScreen(boolean bool) {
        System.out.println("Stats calculator called.");
    }

    private long countDataSets() {
        long count = 0;
        for (Iterator<String> it = MongoConnector.cinebase.listCollectionNames().iterator(); it.hasNext(); ) {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection(it.next());
            count += collection.countDocuments();
        }
        return count;
    }

    public int countCollections() {
        int count = 0;
        for (Iterator<String> it = MongoConnector.cinebase.listCollectionNames().iterator(); it.hasNext(); ) {
            ++count;
            it.next();
        }
        return count;
    }
}
