package SQLHandling;

import extras.FilePicker;

import javax.swing.*;
import java.io.BufferedReader;
import java.io.File;
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

        //createFile = FilePicker.pickv2();

        StringBuilder res = new StringBuilder();
        Statement create_stmt = conn.createStatement();

        FileReader fr = new FileReader(new File(file));
        BufferedReader br = new BufferedReader(fr);
        int j = 0;
        while (j <= 1000) {
            res.append(br.readLine());
            j++;
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
        } catch (IOException ioe) {
            JOptionPane.showMessageDialog(null, "Error while loading file.");
        } catch (SQLException sqle) {
            JOptionPane.showMessageDialog(null, "Error in SQL statement.");
        }
    }
}
