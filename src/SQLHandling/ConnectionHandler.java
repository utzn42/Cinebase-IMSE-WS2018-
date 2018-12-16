package SQLHandling;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnectionHandler {
    private static String databaseURL = "jdbc:mysql://localhost/kino" + "&useSSL=true" + "&requireSSL=true";

    public static boolean connect() {
        try {
            Connection conn = DriverManager.getConnection(databaseURL, LoginDataProvider.user, LoginDataProvider.pass);
        } catch (SQLException e) {
            return false;
        }
        return true;
    }
}
