import cv2
import sys

def crop_qr(image_path, out_path):
    img = cv2.imread(image_path)
    if img is None:
        print("Failed to load image")
        sys.exit(1)

    detector = cv2.QRCodeDetector()
    ret_val, decoded_info, points, _ = detector.detectAndDecodeMulti(img)

    if ret_val and len(points) > 0:
        box = points[0]
        x_min = max(0, int(min(p[0] for p in box)) - 25)
        y_min = max(0, int(min(p[1] for p in box)) - 25)
        x_max = min(img.shape[1], int(max(p[0] for p in box)) + 25)
        y_max = min(img.shape[0], int(max(p[1] for p in box)) + 25)

        cropped = img[y_min:y_max, x_min:x_max]
        cv2.imwrite(out_path, cropped)
        print("Success! Cropped strictly to scanner.")
    else:
        print("No QR code found in image.")
        sys.exit(1)

if __name__ == "__main__":
    crop_qr("scanner.jpeg", "scanner.jpeg")
