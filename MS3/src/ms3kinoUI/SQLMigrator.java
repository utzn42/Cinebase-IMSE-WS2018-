package ms3kinoUI;

import Extras.Defaults;
import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import org.bson.Document;

import javax.swing.*;
import java.net.ConnectException;
import java.sql.*;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Collections;
import java.util.Date;

import static com.mongodb.client.model.Filters.eq;

class SQLMigrator {

  private static String databaseURL = Defaults.databaseURL;
  private static Connection conn;
  private Statement statement;
  private JProgressBar pb;


  SQLMigrator(JProgressBar pb) throws ConnectException, SQLException {

    try {
      conn = DriverManager
          .getConnection(databaseURL, "root", "");
    } catch (SQLException e) {
      throw new ConnectException();
    }
    statement = conn.createStatement();
    this.pb = pb;
    pb.setStringPainted(true);
    pb.setValue(0);
  }

  void migrateAll() throws SQLException, ParseException {
    migrateFilms();
    pb.setValue(pb.getValue() + 1);
    migrateCustomers();
    pb.setValue(pb.getValue() + 1);
    migrateScreenings();
    pb.setValue(pb.getValue() + 1);
    migrateEmployees();
    pb.setValue(pb.getValue() + 1);
    migrateHalls();
    pb.setValue(pb.getValue() + 1);
    migrateSeats();
    pb.setValue(pb.getValue() + 1);
    migrateTickets();
    pb.setValue(pb.getValue() + 1);

    JOptionPane.showMessageDialog(null, "Successfully imported SQL data!");
  }


  private void migrateCustomers() throws SQLException {

    statement.execute("SELECT * FROM customer");

    ResultSet customerSet = statement.executeQuery("SELECT * FROM customer");

    int customer_id = 0;
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
            customer_id = customerSet.getInt(i);
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

  private void migrateFilms() throws SQLException {

    statement.execute("SELECT * FROM film");

    ResultSet filmSet = statement.executeQuery("SELECT * FROM film");

    int film_id = 0;
    String title = "";
    String director = "";
    String country = "";
    String film_language = "";
    int age_rating = 0;
    int duration = 0;

    MongoCollection<Document> collectionFilm = MongoConnector.cinebase
        .getCollection("films");

    while (filmSet.next()) {

      for (int i = 1; i <= filmSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            film_id = filmSet.getInt(i);
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
            age_rating = filmSet.getInt(i);
            break;
          case 7:
            duration = filmSet.getInt(i);
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

  private void migrateScreenings() throws SQLException, ParseException {

    statement.execute("SELECT * FROM screening");

    ResultSet screeningSet = statement.executeQuery("SELECT * FROM screening");

    int screening_id = 0;
    int hall_id = 0;
    int film_id = 0;
    String starting_time = "";

    //TODO: caution: we limited the amount of screenings, because debugging
    int count = 0;
    while (screeningSet.next() && count < 100) {

      for (int i = 1; i <= screeningSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            screening_id = screeningSet.getInt(i);
            break;
          case 2:
            hall_id = screeningSet.getInt(i);
            break;
          case 3:
            film_id = screeningSet.getInt(i);
            break;
          case 4:
            starting_time = screeningSet.getString(i);
            break;
        }

      }

      MongoCollection<Document> collectionFilm = MongoConnector.cinebase
          .getCollection("films");

      //Date date = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(starting_time);

      // Date formattedDate = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'Z'");

      SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

      Date date = format.parse(starting_time);

      Document docScreening = new Document("_id", screening_id)
          //.append("$ref", "halls")
          .append("hall_id", hall_id)
          //.append("$db", "cinebase")
          .append("starting_time", date);

      collectionFilm.updateOne(eq("_id", film_id),
          new Document("$push", new Document("screenings", docScreening)));
      count++;
    }

  }

  private void migrateEmployees() throws SQLException {

    statement.execute("SELECT * FROM employee");

    ResultSet employeeSet = statement.executeQuery("SELECT * FROM employee");

    int employee_nr = 0;
    int manager_id = 0;
    String first_name = "";
    String last_name = "";
    String email = "";
    String password = "";

    MongoCollection<Document> collectionEmployee = MongoConnector.cinebase
        .getCollection("employees");

    Document docEmployee;

    while (employeeSet.next()) {

      for (int i = 1; i <= employeeSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            employee_nr = employeeSet.getInt(i);
            break;
          case 2:
            manager_id = employeeSet.getInt(i);
            break;
          case 3:
            first_name = employeeSet.getString(i);
            break;
          case 4:
            last_name = employeeSet.getString(i);
            break;
          case 5:
            email = employeeSet.getString(i);
            break;
          case 6:
            password = employeeSet.getString(i);
            break;
        }
      }
      docEmployee = new Document("_id", employee_nr)
          .append("manager_id", manager_id)
          .append("first_name", first_name)
          .append("last_name", last_name)
          .append("email", email)
          .append("password", password);
      collectionEmployee.insertOne(docEmployee);
    }
  }

  private void migrateHalls() throws SQLException {

    statement.execute("SELECT * FROM hall");

    ResultSet hallSet = statement.executeQuery("SELECT * FROM hall");

    int hall_id = 0;
    String name = "";
    String equipment = "";

    MongoCollection<Document> collectionHall = MongoConnector.cinebase
        .getCollection("halls");

    while (hallSet.next()) {

      for (int i = 1; i <= hallSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            hall_id = hallSet.getInt(i);
            break;
          case 2:
            name = hallSet.getString(i);
            break;
          case 3:
            equipment = hallSet.getString(i);
            break;
        }
      }
      Document docHall = new Document("_id", hall_id)
          .append("title", name)
          .append("director", equipment);

      collectionHall.insertOne(docHall);
    }
  }

  private void migrateSeats() throws SQLException {

    statement.execute("SELECT * FROM seat");

    ResultSet seatSet = statement.executeQuery("SELECT * FROM seat");

    int seat_id = 0;
    int hall_id = 0;
    int seat_nr = 0;
    int row_nr = 0;

    while (seatSet.next()) {

      for (int i = 1; i <= seatSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            seat_id = seatSet.getInt(i);
            break;
          case 2:
            hall_id = seatSet.getInt(i);
            break;
          case 3:
            seat_nr = seatSet.getInt(i);
            break;
          case 4:
            row_nr = seatSet.getInt(i);
            break;
        }
      }

      MongoCollection<Document> collectionHall = MongoConnector.cinebase
          .getCollection("halls");

      Document docSeat = new Document("_id", seat_id)
          .append("seat_nr", seat_nr)
          .append("row_nr", row_nr);

      collectionHall
          .updateOne(eq("_id", hall_id), new Document("$push", new Document("seats", docSeat)));
    }
  }

  private void migrateTickets() throws SQLException {

    statement.execute("SELECT * FROM ticket");

    ResultSet ticketSet = statement.executeQuery("SELECT * FROM ticket");

    int ticket_id = 0;
    int screening_id = 0;
    int customer_id = 0;
    String price = "";
    String discount_type = "";

    while (ticketSet.next()) {

      for (int i = 1; i <= ticketSet.getMetaData().getColumnCount(); i++) {
        switch (i) {
          case 1:
            ticket_id = ticketSet.getInt(i);
            break;
          case 2:
            screening_id = ticketSet.getInt(i);
            break;
          case 3:
            customer_id = ticketSet.getInt(i);
            break;
          case 4:
            price = ticketSet.getString(i);
            break;
          case 5:
            discount_type = ticketSet.getString(i);
            break;
        }
      }

      MongoCollection<Document> collectionCustomer = MongoConnector.cinebase
          .getCollection("customers");

      Document docTicket = new Document("_id", ticket_id)
          .append("screening_id", screening_id)
          .append("customer_id", customer_id)
          .append("price", price)
          .append("discount_type", discount_type);

      collectionCustomer.updateOne(eq("_id", customer_id),
          new Document("$push", new Document("tickets", docTicket)));

    }
  }
}

