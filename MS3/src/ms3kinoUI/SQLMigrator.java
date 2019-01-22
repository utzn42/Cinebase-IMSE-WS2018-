package ms3kinoUI;

import Extras.Defaults;
import SQLHandling.LoginDataProvider;
import com.mongodb.client.MongoCollection;
import java.net.ConnectException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Collections;
import javax.swing.JOptionPane;
import javax.xml.transform.Result;
import ms3extras.MongoConnector;
import org.bson.Document;

public class SQLMigrator {

  private static String databaseURL = Defaults.databaseURL;
  private static Connection conn;

  public SQLMigrator() throws ConnectException, SQLException {

    try {
      conn = DriverManager
          .getConnection(databaseURL, "root", "imse2018");
    } catch (SQLException e) {
      throw new ConnectException();
    }

    Statement statement = conn.createStatement();

    statement.execute("SELECT * FROM customer");

    ResultSet customerSet = statement.executeQuery("SELECT * FROM customer");

    String customer_id = "";
    String customer_type = "";
    String email = "";
    String password = "";

    ResultSetMetaData customerData = customerSet.getMetaData();
    int customerColumnCount = customerData.getColumnCount();

    MongoCollection<Document> collectionCustomer = MongoConnector.cinebase
        .getCollection("customer");

    Document docCustomer;

    while (customerSet.next()) {

      for (int i = 1; i <= customerColumnCount; i++) {
        switch (i) {
          case 1:
            customer_id = customerSet.getString(i);
            break;
          case 2:
            customer_type = customerSet.getString(i);
            break;
          case 3:
            email = customerSet.getString(i);
            break;
          case 4:
            password = customerSet.getString(i);
            break;
        }
      }
      docCustomer = new Document("customer_id", customer_id)
          .append("customer_type", customer_type)
          .append("email", email)
          .append("password", password);
      collectionCustomer.insertOne(docCustomer);
    }

    JOptionPane.showMessageDialog(null, "Success!");
    new MainScreen().frame.setVisible(true);

  }
}

