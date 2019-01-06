package SQLHandling;

import Extras.Defaults;

import java.net.ConnectException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnectionHandler {
    private static String databaseURL = Defaults.databaseURL;

    private static Connection conn;

    public static Connection connect() throws ConnectException {
        try {
            conn = DriverManager.getConnection(databaseURL, LoginDataProvider.user, LoginDataProvider.pass);
        } catch (SQLException e) {
            throw new ConnectException();
        }
        return conn;
    }
}
