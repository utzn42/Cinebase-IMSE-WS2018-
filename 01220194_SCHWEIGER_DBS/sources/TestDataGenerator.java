import java.sql.*;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.time.Clock;
import java.util.ArrayList;
import oracle.jdbc.driver.*;

public class TestDataGenerator {

    public static void main(String args[]) {

        try {
            Class.forName("oracle.jdbc.driver.OracleDriver");
            String database = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
            String user = "a01220194";
            String pass = "car3grass";

            // establish connection to database
            Connection con = DriverManager.getConnection(database, user, pass);
            Statement stmt = con.createStatement();

            // insert a single dataset into the database
            StringBuilder sb1 = new StringBuilder();



            try{
                stmt = con.createStatement();
            }catch(Exception e){
                System.err.println("problems creating a statement");
            }
            try{






                    //INSERT PROGRAMM
                    String dataPath = "insertAll.sql";

                    FileReader fr = new FileReader(new File(dataPath));
                    BufferedReader br = new BufferedReader(fr);
                    int j = 0;
                    while (j<=3805) {sb1.append(br.readLine());
                        j++;}

                    br.close();

                    String[] insertArray = sb1.toString().split(";");

                    for(int i = 0; i < insertArray.length-1; ++i) {
                        if (!insertArray[i].trim().equals("")) {
                            stmt.executeUpdate(insertArray[i]);
                            System.out.println("[" + i + "] >> " + insertArray[i]);
                        }
                    }












            } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            }

            // check number of datasets in person table
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM programm");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of programm-datasets: " + count);
            }

            rs = stmt.executeQuery("SELECT COUNT(*) FROM film");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of film-datasets: " + count);
            }


            rs = stmt.executeQuery("SELECT COUNT(*) FROM sondervorstellung");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of sondervorstellung-datasets: " + count);
            }


            rs = stmt.executeQuery("SELECT COUNT(*) FROM vorfuehrung");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of vorfuehrung-datasets: " + count);
            }

            rs = stmt.executeQuery("SELECT COUNT(*) FROM saal");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of saal-datasets: " + count);
            }

            rs = stmt.executeQuery("SELECT COUNT(*) FROM sitz");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of sitz-datasets: " + count);
            }

            rs = stmt.executeQuery("SELECT COUNT(*) FROM ticket");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of ticket-datasets: " + count);
            }

            rs = stmt.executeQuery("SELECT COUNT(*) FROM mitarbeiter");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of mitarbeiter-datasets: " + count);
            }

            rs = stmt.executeQuery("SELECT COUNT(*) FROM aufsicht");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of aufsicht-datasets: " + count);
            }

            // clean up connections
            rs.close();
            stmt.close();
            con.close();

        } catch (Exception e) {
            System.err.println(e.getMessage());
        }
    }
}