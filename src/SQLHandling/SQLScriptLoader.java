package SQLHandling;

import extras.FilePicker;

import javax.swing.*;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class SQLScriptLoader {

    public static void loadScript(Connection conn, String file) throws IOException, SQLException {

        if (file == null) {
            file = FilePicker.pickv2();
            file.replace("\\", "\\\\");                                                               //avoid backslash escape character
        }

        StringBuilder res = new StringBuilder();
        Statement create_stmt = conn.createStatement();

        BufferedReader br = new BufferedReader(new FileReader(file));
        String line;
        while ((line = br.readLine()) != null) {
            res.append(line);
        }

        br.close();

        String[] insertArray = res.toString().split(";");

        for (int i = 0; i < insertArray.length - 1; ++i) {
            if (!insertArray[i].trim().equals("")) {
                create_stmt.executeUpdate(insertArray[i]);
                System.out.println("[" + i + "] >> " + insertArray[i]);
            }
        }

        create_stmt.close();
    }

    public static void performLoadScript(Connection conn, String file) {
        try {
            SQLScriptLoader.loadScript(conn, file);
            JOptionPane.showMessageDialog(null, "Success!");
        } catch (IOException ioe) {
            JOptionPane.showMessageDialog(null, "Error while loading file.");
            System.out.println(ioe.getMessage());
        } catch (SQLException sqle) {
            JOptionPane.showMessageDialog(null, "Error in SQL statement.");
            System.out.println(sqle.getMessage());
        }
    }
}
