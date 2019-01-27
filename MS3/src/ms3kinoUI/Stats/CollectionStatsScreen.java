package ms3kinoUI.Stats;

import Extras.Window;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import org.bson.Document;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.util.ArrayList;
import java.util.Iterator;

public class CollectionStatsScreen extends Window {
    private ArrayList<Long> docCounts = new ArrayList<>();
    private ArrayList<String> collNames = new ArrayList<>();
    private JPanel collectionStatspanel;
    private JTable collectionTable;
    private JButton backButton;

    public CollectionStatsScreen() {
        run(collectionStatspanel);
        for (Iterator<String> it = MongoConnector.cinebase.listCollectionNames().iterator(); it.hasNext(); ) {
            MongoCollection<Document> collection = MongoConnector.cinebase.getCollection(it.next());
            collNames.add(collection.toString());
            docCounts.add(collection.countDocuments());
        }

        DefaultTableModel model = (DefaultTableModel) collectionTable.getModel();
        for (int i = 0; i < collNames.size(); ++i) {
            model.addRow(new Object[]{collNames.get(i), docCounts.get(i)});
        }

        backButton.addActionListener(e -> {
            frame.setVisible(false);
        });
    }

    private void createUIComponents() {
        DefaultTableModel model = new DefaultTableModel();
        collectionTable = new JTable(model);
        model.addColumn("Collections");
        model.addColumn("Data sets");
        for (int i = 0; i < collNames.size(); ++i) {
            model.addRow(new Object[]{collNames.get(i), docCounts.get(i)});
        }
    }
}
