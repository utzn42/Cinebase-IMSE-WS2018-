package SQLHandling;

public class LoginDataProvider {
    protected static String user = "root";
    protected static String pass = "imse2018";

    public static int getUserHash() {
        return user.hashCode();
    }

    public static int getPassHash() {
        return pass.hashCode();
    }
}
