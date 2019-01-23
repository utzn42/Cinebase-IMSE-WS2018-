package ms3kinoUI;

import Extras.Defaults;
import com.mongodb.client.MongoCollection;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
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
          .getConnection(databaseURL, "root", "");
    } catch (SQLException e) {
      throw new ConnectException();
    }
    statement = conn.createStatement();
  }

  public void migrateAll() throws SQLException, ConnectException, ParseException {
    migrateFilms();
    migrateCustomers();
    migrateScreenings();
    migrateEmployees();
    migrateHalls();
    migrateSeats();

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

  public void migrateScreenings() throws ConnectException, SQLException, ParseException {

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

      //Date date = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(starting_time);

     // Date formattedDate = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'Z'");

      SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

      Date date = format.parse ( starting_time );

      Document docScreening = new Document("screening_id", screening_id)
          .append("hall_id", hall_id)
          .append("starting_time", date);



      collectionFilm.updateOne(eq("_id", film_id), new Document("$push", new Document("screenings", docScreening)));
    }

  }

    public void migrateEmployees() throws ConnectException, SQLException{

        statement.execute("SELECT * FROM employee");

        ResultSet employeeSet = statement.executeQuery("SELECT * FROM employee");

        String employee_nr = "";
        String manager_id = "";
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
                        employee_nr = employeeSet.getString(i);
                        break;
                    case 2:
                        manager_id = employeeSet.getString(i);
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
                    .append("email",email)
                    .append("password",password);
            collectionEmployee.insertOne(docEmployee);
        }
    }

    public void migrateHalls() throws ConnectException, SQLException{

        statement.execute("SELECT * FROM hall");

        ResultSet hallSet = statement.executeQuery("SELECT * FROM hall");

        String hall_id = "";
        String name = "";
        String equipment = "";

        MongoCollection<Document> collectionHall = MongoConnector.cinebase
                .getCollection("halls");

        while (hallSet.next()) {

            for (int i = 1; i <= hallSet.getMetaData().getColumnCount(); i++) {
                switch (i) {
                    case 1:
                        hall_id = hallSet.getString(i);
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

    public void migrateSeats() throws ConnectException, SQLException{

        statement.execute("SELECT * FROM seat");

        ResultSet seatSet = statement.executeQuery("SELECT * FROM seat");

        String seat_id = "";
        String hall_id = "";
        String seat_nr = "";
        String row_nr = "";

        while (seatSet.next()) {

            for (int i = 1; i <= seatSet.getMetaData().getColumnCount(); i++) {
                switch (i) {
                    case 1:
                        seat_id = seatSet.getString(i);
                        break;
                    case 2:
                        hall_id = seatSet.getString(i);
                        break;
                    case 3:
                        seat_nr = seatSet.getString(i);
                        break;
                    case 4:
                        row_nr = seatSet.getString(i);
                        break;
                }
            }

            MongoCollection<Document> collectionHall = MongoConnector.cinebase
                    .getCollection("halls");


            Document docSeat = new Document("seat_id", seat_id)
                    .append("seat_nr", seat_nr)
                    .append("row_nr", row_nr);

            collectionHall.updateOne(eq("_id", hall_id), new Document("$push", new Document("seats", docSeat)));
        }
    }

    public void migrateTickets() throws ConnectException, SQLException{

        statement.execute("SELECT * FROM ticket");

        ResultSet ticketSet = statement.executeQuery("SELECT * FROM ticket");

        String ticket_id = "";
        String screening_id = "";
        String customer_id = "";
        String price = "";
        String discount_type = "";

        MongoCollection<Document> collectionTicket = MongoConnector.cinebase
                .getCollection("tickets");

        while (ticketSet.next()) {

            for (int i = 1; i <= ticketSet.getMetaData().getColumnCount(); i++) {
                switch (i) {
                    case 1:
                        ticket_id = ticketSet.getString(i);
                        break;
                    case 2:
                        screening_id = ticketSet.getString(i);
                        break;
                    case 3:
                        customer_id = ticketSet.getString(i);
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

            collectionCustomer.updateOne(eq("_id", customer_id), new Document("$push", new Document("tickets", docTicket)));

        }
    }
}

