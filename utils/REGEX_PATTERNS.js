const
    USERNAME_REGEX_PATTERN = [
        "(",
        "[a-zA-Z]{1}",
        "[a-zA-Z0-9]*",
        "[\\._\\-]{0,1}",
        "[a-zA-Z0-9]*",
        ")*",
        "[a-zA-Z]{1}",
        "[a-zA-Z0-9]*",
    ].join(""),
    MAIL_REGEX_PATTERN = [
        "(",
        "[a-zA-Z]{1}",
        "[a-zA-Z0-9]*",
        "[\\._\\-]{0,1}",
        "[a-zA-Z0-9]*",
        ")*",
        "[a-zA-Z0-9]{1}",
        "[@]{1}",
        "(",
        "[a-zA-Z]{1}",
        "[a-zA-Z0-9]*",
        "[_\\-]{0,1}",
        "[a-zA-Z0-9]*",
        ")*",
        "[a-zA-Z0-9]{1}",
        "[\\.]{1}",
        "([a-zA-Z]{2,})",
    ].join(""),
    USERNAME_OR_MAIL_REGEX_PATTERN = [
        "(",
        USERNAME_REGEX_PATTERN,
        "){0,1}",
        "(",
        MAIL_REGEX_PATTERN,
        "){0,1}",
    ].join(""),
    PASSWORD_REGEX_PATTERN = [
        "^(?=.*[a-z])",
        "(?=.*[A-Z])",
        "(?=.*[0-9])",
        "(?=.*[!@#$%^&*_=+\\-])",
        ".{8,20}$",
    ].join("");

const
    USERNAME_MESSAGE = "Cannot have consecutive special characters, and special characters that are not (_-.).",
    MAIL_MESSAGE = "Follow this pattern: \"example@organization.xxx\".",
    USERNAME_OR_MAIL_MESSAGE = USERNAME_MESSAGE + ", " + MAIL_MESSAGE,
    PASSWORD_MESSAGE = "Should at least contain one lowercase "
        + "character, one uppercase character, one digit, and one special character, "
        + "and is between 8 and 20 characters long.";

const REGEX_PATTERNS = {
    username: { value: USERNAME_REGEX_PATTERN, message: USERNAME_MESSAGE },
    mail: { value: MAIL_REGEX_PATTERN, message: MAIL_MESSAGE },
    usernameOrMail: { value: USERNAME_OR_MAIL_REGEX_PATTERN, message: USERNAME_OR_MAIL_MESSAGE },
    password: { value: PASSWORD_REGEX_PATTERN, message: PASSWORD_MESSAGE },
};

export default REGEX_PATTERNS;