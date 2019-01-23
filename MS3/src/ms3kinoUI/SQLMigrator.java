package ms3kinoUI;

import Extras.Defaults;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import org.bson.Document;

import javax.swing.*;
import java.net.ConnectException;
import java.sql.*;
import java.util.Collections;

import static com.mongodb.client.model.Filters.eq;

public class SQLMigrator {

  private static String databaseURL = Defaults.databaseURL;
  private static Connection conn;
  Statement statement;


  public SQLMigrator() throws ConnectException, SQLException {

    try {
      conn = DriverManager
          .getConnection(databaseURL, "root", "imse2018");
    } catch (SQLException e) {
      throw new ConnectException();
    }
    statement = conn.createStatement();
    migrateAll();

  }

  public void migrateAll() throws SQLException, ConnectException {
    migrateFilms();
    migrateCustomers();
    migrateScreenings();

    JOptionPane.showMessageDialog(null, "Success!");
    new MainScreen().frame.setVisible(true);
  }



  public void migrateCustomers() throws ConnectException, SQLException{

    statement.execute("SELECT * FROM customer");

    ResultSet customerSet = statement.executeQuery("SELECT * FROM customer");

    String customer_id = "";
    String customer_type = "";
    String email = "";
    String password = "";

    MongoCollection<Document> collectionCustomer = MongoConnector.cinebase
            .getCollection("customers");

    Document docCustomer;

    while (customerSet.next()) {

      for (int i = 1; i <= customerSet.getMetaData().getColumnCount(); i++) {
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
      docCustomer = new Document("_id", customer_id)
          .append("customer_type", customer_type)
          .append("email", email)
              .append("password", password)
              .append("tickets", Collections.emptyList());
      collectionCustomer.insertOne(docCustomer);
    }


  }

  public void migrateFilms() throws ConnectException, SQLException{

    statement.execute("SELECT * FROM film");

    ResultSet filmSet = statement.executeQuery("SELECT * FROM film");

    String film_id = "";
    String title = "";
    String director = "";
    String country = "";
    String film_language = "";
    String age_rating = "";
    String duration = "";


    MongoCollection<Document> collectionFilm = MongoConnector.cinebase
            .getCollection("films");

    while (filmSet.next()) {

      for (int i = 1; i <= filmSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            film_id = filmSet.getString(i);
            break;
          case 2:
            title = filmSet.getString(i);
            break;
          case 3:
            director = filmSet.getString(i);
            break;
          case 4:
            country = filmSet.getString(i);
            break;
          case 5:
            film_language = filmSet.getString(i);
            break;
          case 6:
            age_rating = filmSet.getString(i);
            break;
          case 7:
            duration = filmSet.getString(i);
            break;
        }
      }
      Document docFilm = new Document("_id", film_id)
          .append("title", title)
          .append("director", director)
          .append("country", country)
          .append("film_language", film_language)
          .append("age_rating", age_rating)
          .append("duration", duration);

      collectionFilm.insertOne(docFilm);
    }


  }

  public void migrateScreenings() throws ConnectException, SQLException{

    statement.execute("SELECT * FROM screening");

    ResultSet screeningSet = statement.executeQuery("SELECT * FROM screening");

    String screening_id = "";
    String hall_id = "";
    String film_id = "";
    String starting_time = "";

    while (screeningSet.next()) {

      for (int i = 1; i <= screeningSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            screening_id = screeningSet.getString(i);
            break;
          case 2:
            hall_id = screeningSet.getString(i);
            break;
          case 3:
            film_id = screeningSet.getString(i);
            break;
          case 4:
            starting_time = screeningSet.getString(i);
            break;
        }
      }

      MongoCollection<Document> collectionFilm = MongoConnector.cinebase
              .getCollection("films");


      Document docScreening = new Document("screening_id", screening_id)
          .append("hall_id", hall_id)
          .append("starting_time", starting_time);

      collectionFilm.updateOne(eq("film_id", film_id), new Document("$push", new Document("screenings", docScreening)));
    }

  }



}

