package extras;

import javax.swing.*;
import javax.swing.filechooser.FileNameExtensionFilter;

public class FilePicker {

    public static String pickv1() {                                                                                     //"schirches" UI
        JFileChooser chooser = new JFileChooser();
        FileNameExtensionFilter filter = new FileNameExtensionFilter(
                "SQL Files", "sql");
        chooser.setFileFilter(filter);
        int returnVal = chooser.showOpenDialog(null);
        if (returnVal == JFileChooser.APPROVE_OPTION) {
            System.out.println("You chose to open this file: " +
                    chooser.getSelectedFile().getAbsolutePath());
            return chooser.getSelectedFile().getAbsolutePath();
        }
        return null;
    }

    public static String pickv2() {
        return null;
    }
}
